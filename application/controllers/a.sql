SELECT latitude, longitude, SQRT(
    POW(69.1 * (latitude - [startlat]), 2) +
    POW(69.1 * ([startlng] - longitude) * COS(latitude / 57.3), 2)) AS distance
FROM TableName HAVING distance < 25 ORDER BY distance;