<?php

namespace Exceptions\Langs;

class Fr extends En{
  public const CAUGHT_EXCEPTION   = "Exception capturée";
  public const UNCAUGHT_EXCEPTION = "Exception non capturée";
  public const NO_LANG_DATA       = "Aucune données n'a été trouvé pour la langue '{%lang}'";
  public const FILE_AND_LINE      = "Fichier {%file} - Ligne {%line}";
  public const FILE_NOT_EXISTS    = "Le fichier {%file} n'existe pas";
}
