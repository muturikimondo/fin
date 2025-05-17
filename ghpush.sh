#!/bin/bash

# Prompt for a commit message
read -p "Enter commit message: " commit_message

# Add all files
git add .

# Commit with the provided message
git commit -m "$commit_message"

# Push to the main branch
git push origin main

