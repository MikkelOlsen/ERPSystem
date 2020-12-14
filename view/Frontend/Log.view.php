<div class="columns">
    <div class="column">
        <div class="box">
            <nav class="level">
                <div class="level-item title is-3 has-text-centered has-text-primary">
                    <h3>
                        Log messages - Status
                    </h3>
                </div>
            </nav>
            <table class="table myTable">
                <thead>
                    <tr>
                        <th>Date / Time</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach (Log::fetchStatusLogs() as $key => $value) {
                            echo '<tr>';
                            echo '<td>' . $value->date .'</td>';
                            echo '<td>' . $value->message . '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="column">
        <div class="box">
            <nav class="level">
                <div class="level-item title is-3 has-text-centered has-text-danger">
                    <h3>
                        Log messages - Error
                    </h3>
                </div>
            </nav>
            <table class="table myTable">
                <thead>
                    <tr>
                        <th>Date / Time</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach (Log::fetchErrorLogs() as $key => $value) {
                            echo '<tr>';
                            echo '<td>' . $value->date .'</td>';
                            echo '<td>' . $value->message . '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>