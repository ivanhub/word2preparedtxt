#
# Preparing text files before being processing
#

for file in *.txt
do
 if [ ! -d "$file" ] && [ "$file" != "script.sh" ]; then
  sed -n -E -e '/1\. /,$ p' "$file" | tr -d '\r'| perl -00pe0 | perl -p -e 's/^ *//'|sed "s/^[ \t]*//"|sed $'s/\t/ /g'|tr -s " " > "$file" 
fi

done
