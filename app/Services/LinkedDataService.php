<?php

namespace App\Services;

use GuzzleHttp\Client;
use DomDocument;
use DomXPath;

class LinkedDataService
{
    /**
     * Return the first matching JSON-LD object from the given URL.
     * 
     * @param string $url The URL to fetch.
     * @param array $wantedTypes An array of JSON-LD types to match against, ie 'Organization', 'Product', etc.
     */
    public function first($url, $wantedTypes) {
        libxml_use_internal_errors(true);
        $client = new Client([
            'timeout'  => 2.0
        ]);
        $response = $client->get($url, [ 
            'headers' => [
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36'
            ]
        ]);
        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $document = new DOMDocument();
        $document->loadHTML($response->getBody(), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $xpath = new DOMXPath($document);

        $query = '//script[contains(@type, "application/ld+json")]/text()';
        $entries = $xpath->query($query);

        foreach ($entries as $entry) {
            $json = json_decode($entry->nodeValue, true);
            if (isset($json['@type']) && in_array($json['@type'], $wantedTypes)) {
                return $json;
            }
        }
    }   
}
