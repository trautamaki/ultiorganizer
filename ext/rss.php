<?php
include_once 'localization.php';
include_once '../lib/feed_generator/FeedWriter.php';
include_once '../lib/feed_generator/FeedItem.php';
include_once '../lib/player.functions.php';
include_once '../lib/accreditation.functions.php';

include_once '../lib/season.functions.php';
include_once '../lib/timetable.functions.php';
include_once '../lib/team.functions.php';
include_once '../lib/series.functions.php';
include_once '../lib/common.functions.php';
include_once '../lib/game.functions.php';

include_once 'classes/Game.php';

$type = RSS2;
$max_items = 25;

$feedtype = "all";
$baseurl = GetURLBase();

if (iget("feed")) {
  $feedtype = iget("feed");
}
if (iget("id1")) {
  $id1 = iget("id1");
} else {
  $id1 = CurrentSeason();
}

$id2 = iget("id2");


//Creating an instance of FeedWriter class.
//The constant RSS2 is passed to mention the version
$feed = new FeedWriter(RSS2);
$feed->setChannelElement('language', GetW3CLocale());
$feed->setChannelElement('pubDate', date(DATE_RSS, time()));

switch ($feedtype) {
  case "gameresults":
    //$cutpos = strrpos($baseurl, "/");
    //$path = substr($baseurl,0,$cutpos); //remove ext

    //series
    if (!empty($id2)) {
      $feed->setTitle(_("Ultimate results") . ": " . SeasonName($id1) . " " . SeriesName($id2));
      $feed->setLink($baseurl . "/?view=played");
      $feed->setDescription(SeasonName($id1) . " " . SeriesName($id2));
      $games = TimetableGames($id2, "series", "past", "timedesc");
      //season
    } else {
      $feed->setTitle(_("Ultimate results") . ": " . SeasonName($id1));
      $feed->setLink($baseurl . "/?view=played");
      $feed->setDescription(SeasonName($id1));
      $games = TimetableGames($id1, "season", "past", "timedesc");
    }
    $i = 0;

    // TODO use game objects
    foreach ($games as $game) {
      if ($i >= $max_items) {
        break;
      }

      if ($game->hasStarted()) {
        $newItem = $feed->createNewItem();
        $newItem->setGuid($game->getId());
        $title = TeamName($game->getHomeTeam());
        $title .= " - ";
        $title .= TeamName($game->getVisitorTeam());
        $title .= " ";
        $title .= $game->getHomeScore();
        $title .= " - ";
        $title .= $game->getVisitorScore();

        $newItem->setTitle($title);
        $newItem->setLink($baseurl . "/?view=gameplay&game=" . $game->getId());

        $desc = U_(SeriesName($game->getSeries()));
        $desc .= " ";
        $desc .= PoolName($game->getPool());
        $newItem->setDescription($desc);

        //Now add the feed item
        $feed->addItem($newItem);
        $i++;
      }
    }
    break;

  case "game":
    //$cutpos = strrpos($baseurl, "/");
    //$path = substr($baseurl,0,$cutpos); //remove ext

    $game = new Game(GetDatabase(), $id1); //GameInfo($id1);
    $goals = $game->getGoals();
    $gameevents = $game->getEvents();
    $mediaevents = $game->getMediaEvents();

    $feed->setTitle(_("Ultimate game") . ": " . TeamName($game->getHomeTeam()) . " - " . TeamName($game->getVisitorTeam()));
    $feed->setLink($baseurl . "/?view=gameplay&game=$id1");
    $feed->setDescription(SeriesName($game->getSeries()) . ", " . PoolName($game->getPool()));

    $prevgoal = 0;
    $items = array();

    while ($goal = GetDatabase()->FetchAssoc($goals)) {
      $newItem = $feed->createNewItem();
      $newItem->setGuid($goal['time']);

      $title = TeamName($game->getHomeTeam());
      $title .= " - ";
      $title .= TeamName($game->getVisitorTeam());
      $title .= " ";
      $title .= intval($goal['homescore']);
      $title .= " - ";
      $title .= intval($goal['visitorscore']);

      if (intval($goal['iscallahan'])) {
        $pass = "xx";
      } else {
        $pass = $goal['assistfirstname'] . " " . $goal['assistlastname'];
      }

      $scorer = $goal['scorerfirstname'] . " " . $goal['scorerlastname'];

      $desc = "[" . SecToMin($goal['time']) . "] ";
      if (!empty($pass) || !empty($scorer)) {
        $desc .= $pass . " --> " . $scorer;
      }

      //gameevents
      foreach ($gameevents as $event) {
        if ((intval($event['time']) >= $prevgoal) &&
          (intval($event['time']) < intval($goal['time']))
        ) {
          if ($event['type'] == "timeout")
            $gameevent = _("Time-out");
          elseif ($event['type'] == "turnover")
            $gameevent = _("Turnover");
          elseif ($event['type'] == "offence")
            $gameevent = _("Offence");

          $desc .= "<br/>[" . SecToMin($event['time']) . "] ";

          if (intval($event['ishome']) > 0)
            $desc .=  $gameevent . " " . TeamName($game->getHomeTeam());
          else
            $desc .= $gameevent . " " . TeamName($game->getVisitorTeam());
        }
      }

      $newItem->setTitle($title);
      $newItem->setLink($baseurl . "/?view=gameplay&game=$id1");
      $newItem->setDescription($desc);

      $items[] = $newItem;
      //$feed->addItem($newItem);

      $prevgoal = intval($goal['time']);
    }


    //gameevents after last goal
    $desc = "";
    foreach ($gameevents as $event) {
      if ((intval($event['time']) >= $prevgoal)) {
        if ($event['type'] == "timeout")
          $gameevent = _("Time-out");
        elseif ($event['type'] == "turnover")
          $gameevent = _("Turnover");
        elseif ($event['type'] == "offence")
          $gameevent = _("Offence");

        if (!empty($desc)) {
          $desc .= "<br/>";
        }
        $desc .= "[" . SecToMin($event['time']) . "] ";

        if (intval($event['ishome']) > 0)
          $desc .=  $gameevent . " " . TeamName($game->getHomeTeam());
        else
          $desc .= $gameevent . " " . TeamName($game->getVisitorTeam());
      }
    }
    if (!empty($desc)) {
      $newItem = $feed->createNewItem();
      $newItem->setTitle(_("Latest events"));
      $newItem->setLink($baseurl . "/?view=gameplay&game=$id1");
      $newItem->setDescription($desc);
      $items[] = $newItem;
    }

    $items = array_reverse($items);
    foreach ($items as $item) {
      $feed->addItem($item);
    }

    break;

  case "all":
    //$cutpos = strrpos($baseurl, "/");
    //$path = substr($baseurl,0,$cutpos); //remove ext

    $feed->setTitle(_("Ultimate results"));
    $feed->setLink($baseurl . "/?view=played");
    $feed->setDescription(_("Ultimate results"));
    $games = Game::getAll(20);

    // TODO use objects
    while (($game_row = GetDatabase()->FetchAssoc($games))) {
      $game = new Game(GetDatabase(), $game_row['game_id']);
      if ($game->hasStarted()) {
        $newItem = $feed->createNewItem();
        $newItem->setGuid($game->getId());
        $title = TeamName($game->getHomeTeam());
        $title .= " - ";
        $title .= TeamName($game->getVisitorTeam());
        $title .= " ";
        $title .= $game->getHomeScore();
        $title .= " - ";
        $title .= $game->getVisitorScore();

        $newItem->setTitle($title);
        $newItem->setLink($baseurl . "/?view=gameplay&game=" . $game->getId());

        $desc = U_(SeasonName($game->getSeason()));
        $desc .= ": ";
        $desc .= U_(SeriesName($game->getSeries()));
        if (!empty($game->getName())) {
          $desc .= " - ";
          $desc .= U_($game->getName());
        } else {
          $desc .= " - ";
          $desc .= U_(PoolName($game->getPool()));
        }
        $newItem->setDescription($desc);

        //Now add the feed item
        $feed->addItem($newItem);
      }
    }
    break;
}

//OK. Everything is done. Now genarate the feed.
$feed->genarateFeed();
