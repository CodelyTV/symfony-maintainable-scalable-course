<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * THE VIDEO CONTROLLER
 * © CodelyTV 2017
 */
class VideoController extends BaseController
{
    /**
     * Method used to create a new video
     * @todo Validate the request
     */
    public function postVideoAction(Request $request)
    {
        // Preparing the sql to create the video
        $sql  = "INSERT INTO video (title, url, course_id) 
                VALUES (\"{$request->get('title')}\",
                        \"{$request->get('url')}\",
                        {$request->get('course_id')}
                )";

        // Prepare doctrine statement
        $stmt = $this->getDoctrine()->getConnection()->prepare($sql);
        $stmt->execute();

        // IMPORTANT: Obtaining the video id. Take care, it's done without another query :)
        $videoId = $stmt->lastInsertId();

        // And we return the video created
        return [
            'id'        => $videoId,
            'title'     => $request->get('title'),
            'url'       => $request->get('url'),
            'course_id' => $request->get('course_id'),
        ];
    }
}
