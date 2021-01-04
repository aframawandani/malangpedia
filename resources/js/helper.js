const monthNames = [
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];

const statuses = {
    1: 'Pending',
    2: 'Menunggu Pembayaran',
    3: 'Menunggu Disetujui',
    4: 'Menunggu Dikirim',
    5: 'Pesanan dalam perjalanan',
    6: 'Telah dikirim sebagian',
    7: 'Selesai',
};

const helper = {
    getDateWithTime(time) {
        const date = new Date(time);

        return `${date.getDate().toString().padStart(2, '0')}-${date.getMonth().toString().padStart(2, '0')}-${date.getFullYear()} ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`;
    },
    getFullDateWithTime(time) {
        const date = new Date(time);

        return `${date.getDate().toString().padStart(2, '0')} ${monthNames[parseInt(date.getMonth())]} ${date.getFullYear()} pukul ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`;
    },
    getOrderStatus(statusIdx) {
        console.log(statusIdx);
        return statuses[statusIdx];
    }
}

export default helper;
