#!/bin/bash
rm -r -f ~/public_html/*
cd ~/s15g03/m2
cp -r ./public/* ~/public_html/
touch ~/public_html/user.php
echo "<?php define('USER', '$USER');" >> ~/public_html/user.php

