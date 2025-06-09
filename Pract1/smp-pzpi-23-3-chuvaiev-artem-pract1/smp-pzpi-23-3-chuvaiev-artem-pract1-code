#!/bin/bash
if [ $# -eq 0 ]; then
  echo "No arguments" >&2
  exit 6
fi

heightTree=$1
widthSnow=$2

if (( heightTree % 2 != 0 )); then
    heightTree=$(($heightTree - 1))
fi

if (( $widthSnow % 2 == 0 )); then
    widthSnow=$(($widthSnow - 1))
fi

checkInput() {
  if [[ $1 -le 0 || $2 -le 0 ]]; then
    echo "Error: Height and width must be positive values" >&2
    return 1
  fi
  if [ $1 -le 7 ] || [ $2 -ne $(($1 - 1)) ] ; then
    echo "Impossible to build a tree." >&2
    return 2
  fi

  return 0
}

error_message=$(checkInput "$heightTree" "$widthSnow" 2>&1)
exit_code=$?

if (( exit_code != 0 )); then
  echo "$error_message" >&2
  exit "$exit_code"
fi

heightPerSection=$((($heightTree - 3) / 2 + 1))
symbol='*'
currentAmountSymbols=1

for (( i=0; i < 2; i++ )); do
    row=""
    for (( j = 0; j < $heightPerSection; j++ )); do
        spaces=""
        symbols=""
        
        spaceCount=$((($widthSnow - $currentAmountSymbols) / 2))
        
        for (( sp = 0; sp < $spaceCount; sp++)); do
            spaces+=" " 
        done
        
        for ((sy = 0; sy < $currentAmountSymbols; sy++)); do
            symbols="$symbols$symbol" 
        done
        
        row="$spaces$symbols"
        echo "$row"
        
        currentAmountSymbols=$(($currentAmountSymbols + 2))
        
        if [[ $symbol == "#" ]]; then
            symbol='*'
        else 
            symbol='#'
        fi
    done
    currentAmountSymbols=3
    heightPerSection=$((heightPerSection - 1))
done

spaceCount=$((($widthSnow - 3) / 2))
counter=0
spaces=""

while [ $counter -ne $spaceCount ]; do
    spaces="$spaces " 
    counter=$((counter + 1))
done

for i in {0,1}; do
    echo "$spaces###"
done

counter=0
row=""
star='*'
until [ $counter -eq $(($widthSnow)) ]; do
    row="$row$star"
    counter=$((counter + 1))
done
echo "$row"