<?php
$sql = "SELECT
 pt.cid,
 vs.vn,
 vs.hn,
 CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname,
 os.height,
 os.bw,
 s.`name`,
 vs.age_y,
 os.bmi,
 os.bps,
 os.bpd,
 os.waist,
 vs.vstdate,
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=76
 ) AS 'FBS',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=77
 ) AS 'BUN',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=78
 ) AS 'Cr',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=841
 ) AS 'Chol',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=843
 ) AS 'TG',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=79
 ) AS 'Uricacid',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=302
 ) AS 'ALK',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=300
 ) AS 'AST',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=301
 ) AS 'ALT',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=4
 ) AS 'Hct',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=41
 ) AS 'Color',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=42
 ) AS 'App',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=44
 ) AS 'Ph',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=43
 ) AS 'Spg',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=45
 ) AS 'Pro',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=51
 ) AS 'Bld',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=53
 ) AS 'WBC',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=52
 ) AS 'RBC',
 ( SELECT lo.lab_order_result 
     FROM lab_head AS lh 
     LEFT OUTER JOIN lab_order AS lo ON (lh.lab_order_number=lo.lab_order_number)
     WHERE lh.vn = vs.vn AND lo.lab_items_code=54
 ) AS 'EPI',
 ( SELECT xp.priority_name 
     FROM xray_report AS xr
     LEFT OUTER JOIN xray_priority AS xp ON xp.xray_priority_id = xr.xray_priority_id
     WHERE xr.vn = vs.vn
 ) AS 'xray'
 FROM vn_stat AS vs
 LEFT OUTER JOIN opdscreen AS os ON vs.vn = os.vn
 LEFT OUTER JOIN sex AS s ON s.`code` = vs.sex
 LEFT OUTER JOIN patient AS pt ON pt.hn = vs.hn
 LEFT OUTER JOIN lab_head AS lh ON lh.vn = vs.vn
 WHERE YEAR(vs.vstdate) LIKE '$selectedYear' AND vs.pttype = '44'
 AND pt.cid = '$cid'";
$result_sql = mysqli_query($conn, $sql);
