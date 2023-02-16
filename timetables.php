<?php

$database = new Database();

if (iget("season")) {
  $season = iget("season");
} else {
  $season = CurrentSeason($database);
}
header("location:?view=games&season=" . $season . "&filter=tournaments&group=all");
