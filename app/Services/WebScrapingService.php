<?php

namespace App\Services;
use Embed\Embed;

class WebScrapingService
{
    /**
     * @var
     */
    private $url;

    /**
     * Set url param
     * 
     * 
     * @param string $url 
     * @return object
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Fetch data by web scraping
     * 
     * 
     * @return mixed
     */
    public function getUrlContents()
    {
        try {
            $embed = new Embed();
            $info = $embed->get($this->url);
            $media_url = '';        
            if($info->image)
            {
                $scheme = $port = $host = $path = '';
                if($info->image->getScheme()) $scheme = $info->image->getScheme()."://";
                if($info->image->getHost()) $host = $info->image->getHost();
                if($info->image->getPort()) $port = ":".$info->image->getPort();
                if($info->image->getPath()) $path = ":".$info->image->getPath();
                $media_url = $scheme.$host.$port.$path;
            }
            return [
                'title' => $info->title,
                'description' => $info->description,
                'media_url' => $media_url
            ];
        } catch (\Exception $e) {
            app('log')->error('Content: ' . $e->getMessage(), $e->getTrace());
            return false;
        }

    }
}
?>