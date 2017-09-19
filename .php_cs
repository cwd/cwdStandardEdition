<?php
/*
 * This file is part of Appliation.
 *
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
$finder = Symfony\CS\Finder::create()
    ->in([__DIR__.'/src', __DIR__.'/tests'])
;
Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader(<<<EOF
This file is part of Application.
(c) 2016 cwd.at GmbH <office@cwd.at>
For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF
);
return Symfony\CS\Config::create()
    ->setUsingCache(true)
    ->addCustomFixers(Cwd\PhpCs\CodingStandard::getCustomFixers())
    ->fixers(Cwd\PhpCs\CodingStandard::PHP7_FIXERS)
    ->finder($finder)
;
