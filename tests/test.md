
# publisher.test.php

```
php publisher.test.php > /tmp/1
```

- bill_distribution_start: 分发开始时间
- bill_status: 发行中
```
mysql > update mdc_bill.bill_infos set bill_distribution_start = NOW(), bill_status = 3 where id = 51;
```

# resaler.test.php
- 修改 $billId
- 修改 $valueId

```
php resaler.test.php > /tmp/2
```

# 兑现：redeem.test.php
- 修改 $billId
- 修改 $instrumentId
- 修改 $valueId

```
php redeem.test.php > /tmp/3
```

# 退货：refund.test.php
- 修改 $appId
- 修改 $appToken
- 修改 $billId
- 重新分发两张券
```
php resaler.test.php > /tmp/resaler1
php resaler.test.php > /tmp/resaler2
```
- 修改 testInstrumentId=[$instrumentId]

```
php refund.test.php > /tmp/4
```


# 分享：transfer.test.php
- 修改 $appId
- 修改 $appToken
- 修改 $billId
- 重新分发 1 张券
```
php resaler.test.php > /tmp/resaler2
```
- 修改 $valueId
- 修改 $instrumentId

```
php transfer.test.php > /tmp/5
```


