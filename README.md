

# Platform
- MySQL
- NSQ
- Redis
- Gearman

# Docker
- bill
- bill-tps-producter
- bill-tps-requester
- bill-tps-resulter
- notify
- sub-common
- sub-transaction

# 运维监控

## Gearamn

```
$ gearadmin -h i2 --status

mdc_transacter_resulter 0       0       1
mdc_transacter_request  0       0       1
mdc_line_seiya  0       0       1
mdc_line_hyoga  0       0       1
```

## Redis
- db 1: USER 
- db 2: TOKEN 
- db 3: TRANSACTION_CODE
- db 8: TRANSACTION_RESULT
