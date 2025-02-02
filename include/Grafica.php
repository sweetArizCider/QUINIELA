<?php
  // Create a Chart Object 
  require("SwiffChart.php");

  $chart= new SwiffChart;

  // Set dynamic data 
  $chart->SetTitle("Movie Revenues");
  $chart->SetCategoriesFromString("Harry Potter;Monsters, Inc.;Lord of the Rings");
  $chart->SetSeriesValuesFromString( 0, "187.8;156.9;121.8" );

  // Load a chart template (aka chart style).
  // Chart Templates contains all the format and layout parameters of the chart.
  // Use Swiff Chart authoring tool to edit a custom chart template. 
  $chart->LoadStyle("bar\SanFrancisco.scs");

  // Generate the Flash movie 
  $chart->ExportAsResponse();
?>
