<?php
// Ambang batas aturan peringatan. Ubah sesuai kebijakan peternakan.
return [
    'stok_minimum_persen'      => 20,   // peringatan bila stok <= 20% dari jumlah awal periode
    'mortalitas_harian_persen' => 0.1,  // peringatan bila ayam mati dalam sehari > 0,1% dari jumlah awal
    'jatuh_tempo_hari'         => 7,    // tagihan belum lunas lebih dari 7 hari sejak tanggal transaksi
];
