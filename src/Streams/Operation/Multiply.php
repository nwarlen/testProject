<?php
/**
 * Created by PhpStorm.
 * User: nwarlen
 * Date: 5/16/14
 * Time: 9:54 AM
 */

namespace Streams\Operation;


use Streams\Data\Point;
use Streams\Data\Stream;

class Multiply
{
    private $validityCheck;

    public function __construct()
    {
        $this->validityCheck = new ValidStreams();
    }


    /**
     * combine()
     *
     * Description: Attempts to multiply all values in stream1 by the values in stream2
     *
     * If a point from either stream is null, the resulting stream at that index will be null.
     *
     * @param Stream $stream1
     * @param Stream $stream2
     * @return null|Stream - The resulting Stream --OR-- null if the two Streams cannot be
     *                       combined
     */
    public function combine(Stream $stream1, Stream $stream2)
    {
        if(!($this->validityCheck->isValid($stream1,$stream2))) {
            return null;
        }

        $basis = $stream1->getBasis();
        $interval = $stream1->getInterval();
        $newStream = new Stream($basis,$interval);

        //find the stream with fewer points
        $numPoints = (($stream1->getSize()) <= ($stream2->getSize()) ? $stream1->getSize() : $stream2->getSize());

        for($index = 0;$index < $numPoints;$index++) {
            $pointToAdd = new Point();
            $pointValue = ($stream1->getPoints()[$index]->getValue()) * ($stream2->getPoints()[$index]->getValue());
            $pointToAdd->setValue($pointValue);
            $newStream->addPoint($pointToAdd);
        }

        return $newStream;
    }
} 