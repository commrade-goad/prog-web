<div class="left-bar secondary-color dark-bg-custom">
    <div class="flex-shrink-0 p-3 dark-bg-custom" style="width: 280px">
        <ul class="list-unstyled ps-0">
            <li class="mb-1 text-white">
                <button
                    class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed text-white fw-bold"
                    data-bs-toggle="collapse"
                    data-bs-target="#home-collapse"
                    aria-expanded="false"
                >
                    Home
                </button>
                <div class="collapse" id="home-collapse" style="">
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
                        } else {
                        echo "<li>";
                        echo "<a";
                        echo " href='#'";
                        echo "class='text-white d-inline-flex text-decoration-none rounded'";
                        echo ">Not Available</a";
                        echo ">";
                        echo "</li>";
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button
                    class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed text-white fw-bold"
                    data-bs-toggle="collapse"
                    data-bs-target="#dashboard-collapse"
                    aria-expanded="false"
                >
                    Dashboard
                </button>
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li>
                            <a
                                href="#"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Overview</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Weekly</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Monthly</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Annually</a
                            >
                        </li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button
                    class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed text-white fw-bold"
                    data-bs-toggle="collapse"
                    data-bs-target="#orders-collapse"
                    aria-expanded="false"
                >
                    Orders
                </button>
                <div class="collapse" id="orders-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li>
                            <a
                                href="#"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >New</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Processed</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Shipped</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Returned</a
                            >
                        </li>
                    </ul>
                </div>
            </li>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <button
                    class="btn btn-toggle d-inline-flex align-items-center rounded border-0 text-white fw-bold"
                    data-bs-toggle="collapse"
                    data-bs-target="#account-collapse"
                    aria-expanded="true"
                >
                    Account
                </button>
                <div class="collapse show" id="account-collapse" style="">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li>
                            <a
                                href="#"
                                class="text-white d-inline-flex text-decoration-none rounded"
                            >Profile</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
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