<?php

/*
 * This file is part of Application.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Translation;

use Symfony\Component\Translation\TranslatorInterface;

/**
  * Class TranslationTrait.
  */
 trait TranslationTrait
 {
     /**
      * @var TranslatorInterface
      */
     protected $translator;

     /**
      * @param TranslatorInterface $translator
      */
     public function setTranslator(TranslatorInterface $translator)
     {
         $this->translator = $translator;
     }

     /**
      * @return TranslatorInterface
      */
     public function getTranslator()
     {
         return $this->translator;
     }
 }
