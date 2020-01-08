echo "loading..."
pid=`pidof Ws_Server`
echo $pid
kill -USR1 $pid
echo "loading success"
