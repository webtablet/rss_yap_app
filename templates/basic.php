<?php

/**
 * This is a template for rendering a feed described as "basic" in the 
 * "Yahoo! Developer's Guide for Feed Templates": 
 * http://public.yahoo.com/~jchu/StdFeedTemplate_TechnicalandDesignGuidance.doc
 * This file assumes a variable named $feedUrl has been defined.
 */

$feed = simplexml_load_file($feedUrl);
?>

<style>
/* wrap app to limit style bleeding from parent */
.wrapper {
    
    /* define app-global settings */
    font-family: arial;
    font-size: 12pt;
}
.wrapper a {
    
    /* we don't ever want links underlined */
    text-decoration: none;
}

/* styles for area above nav */
.wrapper .header .logo {
   background-color: #ccc;
   padding: 10px;
}
.wrapper .header .logo .label {
    /* align label and image right in header (see img styling below) */
    float: right;
    
    /* put some space btwn label and img */
    margin-right: 10px;
}
.wrapper .header .logo img {
    float: right;
    
    /* img is linked, but we don't want the border around it */
    border: none;
}

/* navigation styles */
.wrapper .header .navigation {
   background-color: #000;
   color: #fff;
   padding: 10px;
}
.wrapper .header .navigation .label {
    margin-right: 10px;
    
    /* align label next to ul (see below) */
    float: left;
}
.wrapper .header .navigation ul {
    
    /* remove li bullet points*/
    list-style: none;
    
    /* align ul next to label */
    display: inline;
}
.wrapper .header .navigation li {
    font-weight: bold;
    
    /* add a bit of white space btwn nav items */
    margin-right: 10px;
    
    /* display items horizontally */
    float: left;
}

/* main list styles */
.wrapper .body {
    
    /* remove whitespace above list */
    margin-top: 0px;
    
    /* add whitespace around list */
    padding: 10px;
}
.wrapper .body li {
    margin-bottom: 10px;
    
    /* remove li bullet points*/
    list-style: none;
    
    /* kludge: position relative so we can position pubdate and morelink absolute (see below) */
    position: relative;
    
    /* kludge: if there isn't an image, account for missing space */
    min-height: 100px;

    /* display separator under each item */
    border-bottom: 1px solid #ccc;
    
    /* add whitespace above bottom separator */
    padding-bottom: 10px;
}
.wrapper .body li .image {
    
    /* align img left of text content */
    float: left;
    
    margin-right: 10px;
}
.wrapper .body li .category {
    font-weight: bold;
    margin-bottom: 10px;
}
.wrapper .body li .title {
    font-weight: bold;
    
    /* title is an a-tag.  display block so we can add a margin to it */
    display: block;
    margin-bottom: 10px;
}
.wrapper .body li .description {
    
    /* display block so more link doesn't wrap */
    display: block;
    
    color: #ccc;
}
.wrapper .body li .pubDate {
    
    /* align pub date to right of "more" link */
    float: right;
    
    /* position pub date in lower right corner */
    position: absolute;
    bottom: 10px;
    right: 10px;
    
    color: #ccc;
}

.wrapper .body li .moreLink {
    font-weight: bold;
    
    /* position link in lower left, but next to image (if there is one) */
    position: absolute;
    bottom: 10px;
}
</style>

<div class="wrapper">
    <div class="header">
        <div class="logo">
            <a href="<?= $feed->channel->image->link ?>" class="image"><img src="<?= $feed->channel->image->url ?>"/></a>
        
            <!-- kludge: put label below image to correct funky floating  -->
            <span class="label">Go to: </span>
        
            <div style="clear:both"></div>
        </div>
        <div class="navigation">
            <span class="label">Visit: </span>
            <ul>
                <? foreach($feed->channel->children('http://www.yahoo.com/y-namespace')->navigations->navigation as $navigation): ?>
                    <li>
                        <a href="<?= $navigation->attributes()->url ?>"><?= $navigation->attributes()->title ?></a>
                    </li>
                <? endforeach ?>
            </ul>
            <div style="clear:both"></div>
        </div>
    </div>

    <ul class="body">
        <? foreach($feed->channel->item as $item): ?>
            <li>
                
                <!-- if there is an image defined, display it -->
                <? if($item->children('http://search.yahoo.com/mrss/')->content): ?>
                    <div class="image">
                        <img src="<?= $item->children('http://search.yahoo.com/mrss/')->content->attributes()->url ?>"/>
                    </div>
                <? endif ?>
                
                <div class="category"><?= $item->category ?></div>
                <a href="<?= $item->link ?>" class="title"><?= $item->title ?></a>
                <div class="description"><?= $item->description ?></div>
                <a href="<?= $item->category->attributes()->domain ?>" class="moreLink">More in <?= $item->category ?></a>
                <div class="pubDate"><?= $item->pubDate ?></div>
                <div style="clear:both"></div>
            </li>
        <? endforeach ?>
    </ul>
</div>