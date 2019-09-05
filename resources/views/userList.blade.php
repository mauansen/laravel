<table>
    <thead>
    <tr>
        <th>header</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>微信名</td>
        <td>openid</td>
        <td>操作</td>
    </tr>
    @foreach($last_info as $v)
        <tr>
            <td>{{ $v['nickname'] }}</td>
            <td>{{ $v['openid'] }}</td>
            <td><a href="">查看</a></td>
        </tr>
    @endforeach
    </tbody>
</table>last_info