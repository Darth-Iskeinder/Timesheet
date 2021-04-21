<!-- {{ content() }} -->

<div class="jumbotron" id="overview">
    <div class="container-fluid">
        <h1 class="display-3">Welcome to Timesheet Tracker!</h1>
        <p class="lead">This is a timesheet platform</p>

        <div align="right">
        {%- if logged_in is empty -%}
            {{ link_to(
                    'session/login',
                    '<span class="oi oi-check" aria-hidden="true"></span> Login',
                    'class': 'btn btn-primary btn-lg'
                )
            }}
        {% else %}
            {{ link_to(
                    'users',
                    '<span class="oi oi-account-login" aria-hidden="true"></span> Enter User Panel',
                    'class': 'btn btn-primary btn-lg'
                )
            }}
        {% endif %}
        </div>
    </div>
</div>
