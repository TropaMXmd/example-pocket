## Say, the content site got hacked, therefore when fetching the content URL for content parsing it can keep redirecting, how to solve this scenario?

If the content URL and the URL returned from the webscrapper module is different, it can be identified and this situation may be considered as the content URL is compromised. In this situation the scrapping procedure may be designed not to proceed with scrapping any further and to store in database with a flag.

## Say, the content site got hacked, therefore when fetching the content URL for content parsing it can inject virus / malware / adware. how to guard this?

If the content Base URL and the Base URL returned from the webscrapper module is not different yet the content URL maybe compromised and it can inject malicious data. Returned scrapped data can be validated before storing in database which may guard this situation.

## Say, that URL can contain NSFW contents, how to flag NSFW? so that those don't get included in the suggestion system we may develop in future?

There are available NSFW content checker packages and APIs which can be used to check the content. If the content gets identified as NSFW then a flag may be stored against the content in database.
