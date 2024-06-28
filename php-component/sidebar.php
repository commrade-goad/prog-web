<div class="left-bar secondary-color dark-bg-custom">
    <div class="flex-shrink-0 p-3 dark-bg-custom" style="width: 280px">
        <ul class="list-unstyled ps-0">
            <li class="p-2 mb-1 text-white">
                <button
                    class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed text-white fw-bold"
                    data-bs-toggle="collapse"
                    data-bs-target="#home-collapse"
                    aria-expanded="false"
                >
                    <i class='nf nf-cod-table' style='margin-right:10px;'></i>Table Overview
                </button>
                <div class="collapse mt-2" id="home-collapse" style="">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <?php
                        if (!isset($_SESSION["start"])) {
                            echo "<script>window.location=\"/login\"</script>";
                        }

                        if ($_SESSION["user type"] == 1) {
                            echo "<li>";
                            echo "<a";
                            echo " href='?tview=all'";
                            echo "class='text-white d-inline-flex text-decoration-none rounded'";
                            echo ">Overview all</a";
                            echo ">";
                            echo "</li>";
                            $table_name = $_SESSION["table name"];
                            for ($i=0; $i < count($table_name); $i++) { 
                                 echo "<li>";
                                 echo "<a";
                                 echo " href='?tview=$table_name[$i]'";
                                 echo "class='text-white d-inline-flex text-decoration-none rounded'";
                                 echo ">$table_name[$i]</a";
                                 echo ">";
                                 echo "</li>";
                            }
                        } else {
                            $avail = array("item", "rekening", "dbayarbeli", "dbayarjual");
                            for ($i=0; $i < count($avail); $i++) { 
                                 echo "<li>";
                                 echo "<a";
                                 echo " href='?tview=$avail[$i]'";
                                 echo "class='text-white d-inline-flex text-decoration-none rounded'";
                                 echo ">$avail[$i]</a";
                                 echo ">";
                                 echo "</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li class="p-2 mb-1">
                <button
                    class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed text-white fw-bold"
                    data-bs-toggle="collapse"
                    data-bs-target="#dashboard-collapse"
                    aria-expanded="false"
                >
                    <i class='nf nf-cod-dashboard' style='margin-right:10px;'></i>Dashboard
                </button>
                <div class="collapse mt-2" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li>
                            <a
                                href="/dashboard"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Overview</a
                            >
                        </li>
                        <li>
                            <a
                                href="/dashboard?overview=week"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >This week</a
                            >
                        </li>
                        <li>
                            <a
                                href="/dashboard?overview=month"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >This month</a
                            >
                        </li>
                        <li>
                            <a
                                href="/dashboard?overview=year"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >This year</a
                            >
                        </li>
                        <!-- <li>
                            <a
                                href="/dashboard?overview=mweek"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Weekly</a
                            >
                        </li>
                        <li>
                            <a
                                href="/dashboard?overview=mmonth"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Monthly</a
                            >
                        </li>
                        <li>
                            <a
                                href="/dashboard?overview=myear"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Annually</a
                            >
                        </li> -->
                    </ul>
                </div>
            </li>
            <li class="border-top my-3"></li>
            <li class="p-2 mb-1">
                <button
                    class="btn btn-toggle d-inline-flex align-items-center rounded border-0 text-white fw-bold"
                    data-bs-toggle="collapse"
                    data-bs-target="#account-collapse"
                    aria-expanded="true"
                >
                    <i class='nf nf-md-account' style='margin-right:10px;'></i>Account
                </button>
                <div class="collapse show mt-2" id="account-collapse" style="">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li>
                            <a
                                href="?acc=profile"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Profile</a
                            >
                        </li>
                        <li>
                            <a
                                href="?acc=settings"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Settings</a
                            >
                        </li>
                        <li>
                            <a
                                href="/php-component/logout.php"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Sign out</a
                            >
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
