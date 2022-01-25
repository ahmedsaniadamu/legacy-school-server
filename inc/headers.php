<?php
  // modifying headers to  allow all origin domains to access and use this API.
      header('Access-Control-Allow-Origin:https://legacysecondaryschool.netlify.app');
      header('Access-Control-Allow-Methods:GET,POST') ;
      header('Access-Control-Allow-Headers:Content-Type') ;
      header('Content-Type:application/json')
  ?>
