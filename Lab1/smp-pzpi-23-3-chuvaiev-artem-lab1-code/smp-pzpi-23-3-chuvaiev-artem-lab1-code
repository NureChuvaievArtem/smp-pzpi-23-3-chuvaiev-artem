#!/bin/bash

echo_help() {
    echo "Usage: {login_name}-task2 [--help | --version] | [[-q|--quiet] [group] [cist_file.csv]"
    echo
    echo "Options:"
    echo "  --help           Show Description"
    echo "  --version        Show script version"
    echo "  -q, --quiet      Don't output information to STDOUTPUT"
    echo "  cist_file.csv    Path to CSV (Optional)"
    echo "  group            Academic Group (Optional)"
}

display_version() {
    echo "task2 version 1.0.0"
}

chooseFile(){
    if [[ -z "$csv_file" ]]; then
        pattern="TimeTable_??_??_20??.csv"

        files=($(ls -1t $pattern))
        
        if [[ ${#files[@]} -eq 0 ]]; then
            echo "No files found according to pattern: $pattern"
            exit 1
        fi

        echo "Select File:"
        select file in "${files[@]}"; do
            if [[ -n "$file" ]]; then
                echo "You've selected: $file"
                csv_file=$file
                break
            else
                echo "Wrong choice, try again"
            fi
        done
    fi

    if [ ! -e "$csv_file" ]; then
        echo "File doesn't exist"
        exit 1
    fi

    if [ ! -r "$csv_file" ]; then
        echo "File is not readable"
        exit 1
    fi
}

chooseGroup(){
    groups=($(iconv -f cp1251 -t UTF-8 "$csv_file" | tr '\r' '\n' | awk -F',' 'NR > 1 {print substr($1,2,10)}' | sort | uniq))

    if [[ -z "$academic_group" && ${#groups[@]} -eq 1 ]]; then 
        academic_group=${groups[0]}
        echo "Only one group found: $academic_group. Using this group."
    elif [[ -z "$academic_group" ]]; then 
        echo "Select group"
        select group in ${groups[@]}; do
            if [[ -n "$group" ]]; then
                academic_group=$group
                break
            else
                echo "Wrong choice, try again"
            fi
        done
    elif [[ ! " ${groups[*]} " =~ " ${academic_group} " ]]; then
        echo "No specified group found in a file, select different one: "
        select group in ${groups[@]}; do
            if [[ -n "$group" ]]; then
                academic_group=$group
                break
            else
                echo "Wrong choice, try again"
            fi
        done
    fi
}

process_data() {
    iconv -f cp1251 -t UTF-8 "$csv_file" | tr '\r' '\n' | awk -F'","' -v academic_group="$academic_group" '
    function formatTime(timeStr,   parts, hour, minute, ampm, result) {
        split(timeStr, parts, ":");
        hour = parts[1] + 0;
        minute = parts[2];
        ampm = (hour >= 12) ? "PM" : "AM";
        hour = (hour % 12 == 0) ? 12 : (hour % 12);
        result = (hour < 10 ? "0" hour : hour) ":" minute " " ampm;
        return result;
    }

    {
        split($1, temp_group, " ")
        if (temp_group[1] ~ academic_group && (length(temp_group[1]) - 1) == length(academic_group)) {
            subject = substr($1, 2)
            sub("^" academic_group " - ", "", subject)

            split($2, date, ".");
            formattedStartDate = date[2] "/" date[1] "/" date[3];

            split($4, date, ".");
            formattedEndDate = date[2] "/" date[1] "/" date[3];

            formattedStartTime = formatTime($3)
            formattedEndTime = formatTime($5)

            print subject "|" formattedStartDate "|" formattedStartTime "|" formattedEndDate "|" formattedEndTime "|" $12
        }
    }' | sort -t"|" -k1,1 -k2,2 | awk -F'|' -v prevName="$prevName" -v counter="$counter" -v pair_counter="$pair_counter" '
    {
        if(NR == 1){
            print("Subject,Start Date,Start Time,End Date,End Time,Description");
        }
        if($1 == prevName){
            if($1 ~ "Лб"){
                if(pair_counter % 2 == 1){
                    print($1 "; №" counter "," $2 "," $3 "," $4 "," $5 "," $6)
                } else { 
                    counter += 1 
                    print($1 "; №" counter "," $2 "," $3 "," $4 "," $5 "," $6)
                }
                pair_counter += 1 
            } else { 
                counter += 1  
                print($1 "; №" counter "," $2 "," $3 "," $4 "," $5 "," $6)
            }
        } else {
            pair_counter = 1
            counter = 1
            print($1 "; №" counter "," $2 "," $3 "," $4 "," $5 "," $6)
        }
        prevName = $1 
    }'
}

quiet_mode=false

while [[ $# -gt 0 ]]; do
    case "$1" in
        --help)
            echo_help
            exit 0
            ;;
        --version)
            display_version
            exit 0
            ;;
        -q|--quiet)
            quiet_mode=true
            shift
            ;;
        *)
            break
            ;;
    esac
done

if [[ $# -eq 1 ]]; then
    csv_file="$1"
else
    academic_group="$1"
    csv_file="$2"
fi

chooseFile
chooseGroup

if [[ "$quiet_mode" == true ]]; then
    process_data > "Google_${csv_file}" 
    status=$?
else
    process_data | tee "Google_${csv_file}"
    status=${PIPESTATUS[0]}
fi

if [[ $status -ne 0 ]]; then
    echo "Error occured while processing the file"
    exit 2
fi

exit 0