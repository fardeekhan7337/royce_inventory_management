<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
class ArchivedCallContext extends InstanceContext {
    /**
     * Initialize the ArchivedCallContext
     *
     * @param Version $version Version that contains the resource
     * @param \DateTime $date The date of the Call in UTC.
     * @param string $sid The unique string that identifies this resource
     */
    public function __construct(Version $version, $date, $sid) {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['date' => $date, 'sid' => $sid, ];

        $this->uri = '/Archives/' . \rawurlencode($date->format('Y-m-d')) . '/Calls/' . \rawurlencode($sid) . '';
    }

    /**
     * Delete the ArchivedCallInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool {
        return $this->version->delete('DELETE', $this->uri);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Voice.V1.ArchivedCallContext ' . \implode(' ', $context) . ']';
    }
}