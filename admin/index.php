<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=close,grid_view,person_outline,receipt_long,settings,add" /> -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />


    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="left">


            <div class="top">
                <div class="logo">Juju Dhau</div>
                <div class="close">
                    <span class="material-symbols-outlined">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="#">
                    <span class="material-symbols-outlined">
                        grid_view
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-outlined">
                        person_outline
                    </span>
                    <h3>Customer</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">
                        receipt_long
                    </span>
                    <h3>Products</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                    <h3>setting</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    <h3>Add Product</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>

            </div>
        </div>
        <div class="main">
            <h1>Dashboard</h1>
            <div class="date">
                <input type="date">
            </div>
            <div class="insight">
                <!-- selling -->
                <div class="sales">
                    <span class="material-symbols-outlined">trending_up</span>
                    <div class="middle">
                        <div class="mleft">
                            <h3>Today's Sales</h3>
                            <h1>25,05</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle r="30" cy="40" cx="40"></circle>
                            </svg>
                            <div class="number">80%</div>
                        </div>
                    </div>
                    <small>Last 24 Hr</small>
                </div>
                <!-- endselling -->
                <!-- expenses -->
                <div class="expenses">
                    <span class="material-symbols-outlined">local_mall</span>
                    <div class="middle">
                        <div class="mleft">
                            <h3>Today's Expenses</h3>
                            <h1>25,05</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle r="30" cy="40" cx="40"></circle>
                            </svg>
                            <div class="number">80%</div>
                        </div>
                    </div>
                    <small>Last 24 Hr</small>
                </div>
                <!-- endselling -->
                <!-- income -->
                <div class="income">
                    <span class="material-symbols-outlined">stacked_line_chart</span>
                    <div class="middle">
                        <div class="mleft">
                            <h3>Today's income</h3>
                            <h1>25,05</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle r="30" cy="40" cx="40"></circle>
                            </svg>
                            <div class="number">80%</div>
                        </div>
                    </div>
                    <small>Last 24 Hr</small>
                </div>
                <!-- endselling -->

            </div>
            <!-- endinside -->
            <!-- startrecentorder -->
            <div class="recentorder">
                <h1>Recent Order</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Number</th>
                            <th>Payments</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Matkadhau</td>
                            <td>456</td>
                            <td>due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>

                        </tr>
                        <tr>
                            <td>Matkadhau</td>
                            <td>456</td>
                            <td>due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>

                        </tr>
                        <tr>
                            <td>Matkadhau</td>
                            <td>456</td>
                            <td>due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- rightside -->
        <div class="right">
            <div class="rtop">
                <button id="menubar">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="theme">
                    <span class="material-symbols-outlined active">light_mode</span>
                    <span class="material-symbols-outlined">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p><b>Robot</b></p>
                        <p>Admin</p>
                        <small class="textmuted"></small>
                   </div>
                    <div class="profilephoto">
                        <img src="image/pphoto.jpg" alt="loading fail">
                    </div>
                </div>
            </div>
            <!-- endtop -->
            <!-- startrecentupdate -->
            <div class="recentupdate">
                <h2>Recent Update</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profilephoto">
                            <img src="image/pphoto.jpg" alt="">
                        </div>
                        <div class="message">
                            <p><b>Luffy </b>Receive his order</p>
                        </div>
                    </div>
                    <div class="update">
                        <div class="profilephoto">
                            <img src="image/pphoto.jpg" alt="">
                        </div>
                        <div class="message">
                            <p><b>Luffy </b>Receive his order</p>
                        </div>

                    </div>
                    <div class="update">
                        <div class="profilephoto">
                            <img src="image/pphoto.jpg" alt="">
                        </div>
                        <div class="message">
                            <p><b>Luffy </b>Receive his order</p>
                        </div>

                    </div>
                </div>

            </div>

            <!-- end recentupdate -->
            <!-- startsell analytics -->


            <div class="salesanalytics">
                <h2>Sale Analytics</h2>
                <div class="itemonline">
                    <div class="icon">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </div>
                    <div class="righttext">
                        <div class="info">
                            <h3>online order</h3>
                            <small class="textmuted">Last seen 2 Hours</small>
                        </div>
                        <h5 class="danger">-17%</h5>
                        <h3>3493</h3>

                    </div>
                </div>
                <div class="itemonline">
                    <div class="icon">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </div>
                    <div class="righttext">
                        <div class="info">
                            <h3>online order</h3>
                            <small class="textmuted">Last seen 2 Hours</small>
                        </div>
                        <h5 class="danger">-17%</h5>
                        <h3>3493</h3>

                    </div>
                </div>
                <div class="itemonline">
                    <div class="icon">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </div>
                    <div class="righttext">
                        <div class="info">
                            <h3>online order</h3>
                            <small class="textmuted">Last seen 2 Hours</small>
                        </div>
                        <h5 class="danger">-17%</h5>
                        <h3>3493</h3>

                    </div>
                </div>
            </div>






        </div>
    </div>
</body>

</html>