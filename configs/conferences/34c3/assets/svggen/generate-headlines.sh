#!/bin/bash
for i in "34C3 Streaming" "beta" "Feedback" "Info" "Live Music" "Live" "Specials" "Recordings" "Releases" "TLS" "Relive"; do
	echo "$i"
	bash generate-headline.sh "$i"
done
