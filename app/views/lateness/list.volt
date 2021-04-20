{{ content() }}
<div class=container>
<ul class="pager">
        <li class="previous pull-left">
            {{ link_to("lateness/index", "Go Back") }}
        </li>
    </ul>

<h1>List of lateness by user</h2>

<table>

  {% for userLate in userLateness %}
  <tr>
      <td>{{userLate.lateness}} </td>
        <td width="7%">
          {{ link_to("lateness/delete/" ~ userLate.id, "Delete") }}
        </td>
  </tr>
    {% endfor %}
 </table>

</div>