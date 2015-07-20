#!/bin/bash
cp extra/hooks/* .git/hooks
cp extra/hooks/post-checkout ./.git/hooks/post-merge
chmod +x .git/hooks/*
