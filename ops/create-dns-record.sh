#!/bin/bash

# Check jq version in use
jq=$(jq --version)
echo "Jq versions is $jq"

# Run the AWS CLI command to list resource record sets
record_sets=$(aws route53 list-resource-record-sets \
  --hosted-zone-id "$HOSTED_ZONE_ID" \
  --query "ResourceRecordSets[?Name == '$APP_URL.']" \
  --output json)

# Check if the record_sets variable is empty (DNS entry doesn't exist)
if echo "$record_sets" | jq -e '.[].Name | test("'$URL1'\\.'$URL2'\\.'$URL3'")' > /dev/null; then
  echo "DNS entry $APP_URL exists."
  exit 0
else
  echo "Creating DNS entry for $APP_URL..."
  touch route53.json
cat >route53.json <<EOF
{
  "Comment": "CREATE record ",
  "Changes": [{
  "Action": "CREATE",
    "ResourceRecordSet": {
      "Name": "$APP_URL",
      "Type": "A",
      "TTL": 300,
      "ResourceRecords": [{ "Value": "$SERVER_IP"}]
  }}]
}
EOF
  cat route53.json
  aws route53 change-resource-record-sets --hosted-zone-id "$HOSTED_ZONE_ID" --change-batch file://route53.json
fi
