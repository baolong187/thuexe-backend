<!DOCTYPE html>
<html>
<head>
    <title>Thuexe.com</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
    <p>Xe bạn thuê là: {{$car->name }}. Biển số: {{$car->licensePlate}}</p>
    <p>Ngày thuê: {{$bill->startDate}}</p>
    <p>Ngày trả xe: {{$bill->endDate}}</p>
    <p>Tổng tiền: {{number_format($bill->totalPrice,0,',',',')}} vnd.</p>
    <p>Địa điểm nhận xe: Trần Phú, P. Mộ Lao, Hà Đông, Hà Nội</p>
    <p>Quý khách vui lòng liên hệ với số điện thoại bên dưới để biết thời gian nhận xe</p>
    <p>Nếu sau một ngày không lấy xe, đơn sẽ bị hủy</p>
    <p>Số điện thoại liên hệ: 0938828266</p>
</body>
</html>