# twitter-conversations
Library for working with conversations and threads in Twitter
As client to the Twitter API we use https://github.com/abraham/twitteroauth

TO DO LIST:

-Working tests

-Documentation

-Features

-Documentation

SIMPLE USE:

Main classes are TweetRequester and ConversationManager.

TweetRequester request tweets to the API. Each "get" method makes a single request to the API.

ConversationManager uses TweetRequester for relationship between Tweets. Each method can make multiple API calls.

Output are self-explanatory Tweet and TwitterUser objetcs.
