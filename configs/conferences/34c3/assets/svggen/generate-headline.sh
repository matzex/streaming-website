#!/bin/bash
set -e
title=$*
ofile=`echo "$title" \
	| tr '[:upper:]' '[:lower:]' \
 	| tr ' .' '__'`.svg

echo "$ofile" >> error.log

cat vorlage.svg \
	| sed -e "s/34C3 Streaming/${title}/" \
	> ink_${ofile}

inkscape --verb=FitCanvasToDrawing --verb=FileSave --verb=FileQuit \
	ink_${ofile} \
	2>> error.log

inkscape ink_${ofile} \
	--verb=FitCanvasToDrawing --export-area-drawing --export-text-to-path \
	--export-plain-svg=${ofile} \
	2>> error.log
