題目一
SELECT bnbs.id as bnb_id, bnbs.name as bnb_name, orders.amount as may_amount
FROM bnbs INNER JOIN rooms ON bnbs.id=orders.bnb_id
WHERE currency=`TWD` 
ORDER BY orders.amount DESC
LIMIT 10;

題目二
1. 確認各表關聯的欄位有索引
2. 根據需要排序的資料建立索引(amount)
3. 考慮使用EXPLAIN查看執行計畫，確認是否有使用到索引


API 實作測驗
題目一

