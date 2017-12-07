# Обработать все .txt файлы в папке //  Process all .txt files in the folder 
for file in *.txt
do
 if [ ! -d "$file" ] && [ "$file" != "script.sh" ]; then
  php7.1 test2.php "$file"
fi

done
