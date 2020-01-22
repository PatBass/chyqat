<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 6/29/15
 * Time: 8:21 PM
 */

namespace Advertproject\PlatformBundle\Beta;


use Symfony\Component\HttpFoundation\Response;

class BetaHTML
{
    public function addBeta(Response $response, $remainingDays)
    {
        $content = $response->getContent();

        $html = '<span style="font-size:0.6em;color:red;font-weight:bold;"></span>';

        $content = preg_replace(
            '#<h1>(.*?)</h1>#iU',
            '<h1>$1'.$html.'</h1>',
            $content,
            1
        );

        $response->setContent($content);

        return $response;
    }
} 