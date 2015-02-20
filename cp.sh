#!/bin/bash
rm -rf /tmp/copy
cp -r . /tmp/copy
rm -rf /tmp/copy/.svn
rm -rf /tmp/copy/.idea
rm -rf /tmp/copy/.DS_Store
sudo cp -r /tmp/copy/ /Library/WebServer/Documents/
sudo rm -rf /Library/WebServer/Documents/index.html
sudo rm -rf /Library/WebServer/Documents/cp.sh