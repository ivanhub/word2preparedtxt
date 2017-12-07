#
# Extract images and document.xml from Word (.docx) files.
#

for file in *.docx
do
 if [ ! -d "$file" ] && [ "$file" != "script-pic.sh" ]; then
#  sed -n -E -e '/1\. /,$ p' "$file" | tr -d '\r'| perl -00pe0 | perl -p -e 's/^ *//'|sed "s/^[ \t]*//"|sed $'s/\t/ /g'|tr -s " " > "$file.txt" 
#   mv "$file" "$file".zip
   unzip -o -p "$file" word/document.xml > "$file".xml
   unzip -o -j "$file" "word/media/*" -d "$file-images"
   xml fo "$file".xml > "$file"-formatted.xml
   mv "$file"-formatted.xml "$file".xml
fi

done
