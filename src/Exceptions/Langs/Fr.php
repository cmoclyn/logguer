<?php

namespace Exceptions\Langs;

class Fr extends En{
  const CAUGHT_EXCEPTION   = "Exception capturée";
  const UNCAUGHT_EXCEPTION = "Exception non capturée";
  const NO_LANG_DATA       = "Aucune données n'a été trouvé pour la langue '{%lang}'";
  const FILE_AND_LINE      = "Fichier {%file} - Ligne {%line}";
  const FILE_NOT_EXISTS    = "Le fichier {%file} n'existe pas";
}
