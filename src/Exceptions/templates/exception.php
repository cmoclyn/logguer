<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex,nofollow" />
    <title><?= $textCaughtException; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>

  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-12">
        <div class="alert alert-<?= $typeException; ?>">
          <strong><?= $textCaughtException; ?></strong><br />
          [<?= get_class($exception); ?>] <?= $exception->getMessage(); ?><br />
          <small><?= $textFileAndLine; ?></small>
        </div>
        <?php

          $str = "<table class='table'>
                    <tr>
                      <th colspan='2'>Trace :</th>
                    </tr>";

          foreach($exception->getTrace() as $trace){
            $params = $this->formatArgs($trace['args']);
            $file = '';
            if(isset($trace['file'])){
              $file = "{$trace['file']} : {$trace['line']}";
            }
            $class = '';
            if(isset($trace['class'])){
              $class = "{$trace['class']}{$trace['type']}";
            }
            $str .= "<tr>
                      <td>{$file}</td>
                      <td>{$class}{$trace['function']}({$params})</td>
                    </tr>";
          }
          $str .= "</table>";
          echo $str;
        ?>
      </div>
    </div>
  </div>
