{{ content() }}
<div class=container>
<ul class="pager">
        <li class="previous pull-left">
            {{ link_to("user/index", "Go Back") }}
        </li>
    </ul>
<h1>List of lateness</h2>
{% for user in users %}

<table>
    <tr>
        <td>{{user.name}}</td>
        <td width="7%">
            {{ link_to("lateness/list/" ~ user.id, "User lateness") }}
        </td>
    </tr>
</table>
{% endfor %}
</div>