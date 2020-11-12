# -*- coding: utf-8 -*-
"""
Created on Thu Nov  5 19:56:13 2020

@author: shaoqian
"""

import pandas as pd
import numpy as np  
from textblob import TextBlob

reviews = pd.read_csv('@JoeBiden.csv', encoding = 'utf-8')

df_JB['Biden'] = df_JB['tweet_text'].apply(lambda x : 1 if '@JoeBiden' in x else 0)
df_DT['Trump'] = df_DT['tweet_text'].apply(lambda x : 1 if '@realDonaldTrump' in x else 0)

df_DT['Biden'] = np.where(df_DT['tweet_text'].str.contains("@JoeBiden|Biden|biden|Joe|joe|Biden's|biden's|Joe's|joe's"), 1, 0)
df_JB['Trump'] = np.where(df_JB['tweet_text'].str.contains("@realDonaldTrump|Trump|trump|Donald|donald|Trump's|trump's|Donald's|donald's"), 1, 0)


def text_senti_pol(text): 
    return TextBlob(text).sentiment.polarity

def text_senti_sub(text): 
    return TextBlob(text).sentiment.subjectivity

def add_expression_col(pure_text_df):
    # @pure_text_df: entire dataset contains column ["tweet_text"]
    df0 = pd.DataFrame()
    df0 = pure_text_df
    df0['Polarity'] = pure_text_df['tweet_text'].apply(text_senti_pol)
    df0['Subjectivity'] = pure_text_df.tweet_text.apply(text_senti_sub)
    df0['Expression'] = np.where(df0['Polarity']>0,'positive', 'negative')
    df0['Expression'][df0.Polarity ==0] = "Neutral"
    return df0

df2 = add_expression_col(reviews)