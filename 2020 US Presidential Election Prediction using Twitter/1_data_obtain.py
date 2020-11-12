#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Oct  7 12:28:55 2020

@author: shaoqianchen
"""


import csv
import tweepy
import ssl
import time
from datetime import datetime
import pandas as pd

#Twitter API account @chenshaoqian
consumer_key = "vm0Abd55uNcNsXzB4W9jA0doD"
consumer_secret = "a5C8ssiL2lXigrlwfBjhiA3il7HDSJzKHpujZwmRCG05HCXmE6"
access_token = "2477646506-pbeQzzEKUqLYffU0v1i00Is67xBAKnqvggMtSwQ"
access_token_secret = "aZvxJ36EVFxjNZTS7RRXZlHpQ039SA2XblUCZf8hb0UcU"



def search_tag(consumer_key,consumer_secret,access_token,access_token_secret,tag,num_scrap,since_date,until_date):
    begin = time.time()
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
    auth.set_access_token(access_token, access_token_secret)
    #ssl._create_default_https_context = ssl._create_unverified_context
    api = tweepy.API(auth)
    api = tweepy.API(auth, wait_on_rate_limit=True)
    #get the name of the spreadsheet we will write to
    fname = tag+since_date
    #open the spreadsheet we will write to 
    with open('%s.csv' % (fname), 'w') as file:
        w = csv.writer(file)
        #write header row to spreadsheet
        w.writerow(['timestamp', 'tweet_text', 'username', 'all_hashtags', 'followers_count'])
        #for each tweet matching our hashtags, write relevant info to the spreadsheet
        for tweet in tweepy.Cursor(api.search, q=tag+' since:'+since_date+' until:'+until_date+' -filter:retweets', \
                                   lang="en",tweet_mode='extended').items(num_scrap):
            w.writerow([tweet.created_at, tweet.full_text.replace('\n',' ').encode('utf-8'),\
                        tweet.user.screen_name.encode('utf-8'), [e['text'] for e in tweet._json['entities']['hashtags']], \
                            tweet.user.followers_count])
    end = time.time()
    print("Finished scraping ",num_scrap, " tweets includes ",tag, " within ",end-begin," second")



candidate = ['@realDonaldTrump','@JoeBiden']

for i in candidate:    
    search_tag(consumer_key,consumer_secret,access_token,access_token_secret,i,5000,"2020-10-29","2020-10-30")
    

#search_tag(consumer_key,consumer_secret,access_token,access_token_secret,'@JoeBiden',5000,"2020-10-28","2020-10-29")



#A = pd.date_range(start="2018-09-09",end="2020-02-02")


"""search_term = "@realDonaldTrump -filter:retweets"



tweets = tweepy.Cursor(api.search,
                   q=search_term,
                   lang="en",
                   since='2019-11-01').items(100)

all_tweets = [tweet.text for tweet in tweets]

all_tweets[:5]"""