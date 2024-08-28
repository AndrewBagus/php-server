<?php

/** 
 * Display a list of predefined database servers to login with just one click.
 * Don't use this in production enviroment unless the access is restricted
 *
 * @link https://www.adminer.org/plugins/#use
 * @author Gio Freitas, https://www.github.com/giofreitas
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
class OneClickLogin
{
    /** @access protected */
    var $servers, $driver;

    /** 
     *
     * Set supported servers
     * @param array $servers
     * @param string $driver
     */
    function __construct($servers, $driver = "server")
    {

        $this->servers = $servers;
        $this->driver = $driver;
    }

    function login($login, $password)
    {
        // check if server is allowed
        return isset($this->servers[SERVER]);
    }

    function databaseValues($server)
    {
        $databases = $server['databases'];
        if (is_array($databases))
            foreach ($databases as $database => $name) {
                if (is_string($database))
                    continue;
                unset($databases[$database]);
                if (!isset($databases[$name]))
                    $databases[$name] = $name;
            }
        return $databases;
    }

    function loginForm()
    {
?>
        </form>
        <div>
            <table cellspacing="0" class="layout">
                <tbody>
                    <tr>
                        <th>System</th>
                        <td><select name="auth[driver]">
                                <option value="server" selected="">MySQL</option>
                                <option value="sqlite">SQLite 3</option>
                                <option value="sqlite2">SQLite 2</option>
                                <option value="pgsql">PostgreSQL</option>
                                <option value="oracle">Oracle (beta)</option>
                                <option value="mssql">MS SQL (beta)</option>
                                <option value="mongo">MongoDB (alpha)</option>
                                <option value="elastic">Elasticsearch (beta)</option>
                            </select>
                            <script nonce="">
                                qsl('select').onchange = function() {
                                    loginDriver(this);
                                };
                            </script>
                        </td>
                    </tr>
                    <tr class="">
                        <th>Server</th>
                        <td><input name="auth[server]" value="" title="hostname[:port]" placeholder="localhost" autocapitalize="none">
                        </td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><input name="auth[username]" id="username" value="" autocomplete="username" autocapitalize="none">
                            <script nonce="">
                                focus(qs('#username'));
                                qs('#username').form['auth[driver]'].onchange();
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><input type="password" name="auth[password]" autocomplete="current-password">
                        </td>
                    </tr>
                    <tr>
                        <th>Database</th>
                        <td><input name="auth[db]" value="" autocapitalize="none">
                        </td>
                    </tr>
                </tbody>
            </table>
            <p>
                <input type="submit" value="Login" class="">
                <label><input type="checkbox" name="auth[permanent]" value="1" checked="">Permanent login</label>
            </p>
        </div>
        <div>
            <table>
                <tr>
                    <th><?php echo lang('Server') ?></th>
                    <th><?php echo lang('User') ?></th>
                    <th><?php echo lang('Database') ?></th>
                </tr>

                <?php
                foreach ($this->servers as $host => $server) :


                    $databases = isset($server['databases']) ? $server['databases'] : "";
                    if (!is_array($databases))
                        $databases = array($databases => $databases);

                    foreach (array_keys($databases) as $i => $database) :
                ?>
                        <tr>
                            <?php if ($i === 0) : ?>
                                <td style="vertical-align:middle" rowspan="<?php echo count($databases) ?>"><?php echo isset($server['label']) ? "{$server['label']} ($host)" : $host; ?></td>
                                <td style="vertical-align:middle" rowspan="<?php echo count($databases) ?>"><?php echo $server['username'] ?></td>
                            <?php endif; ?>
                            <td style="vertical-align:middle"><?php echo $databases[$database] ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="auth[driver]" value="<?php echo $this->driver; ?>">
                                    <input type="hidden" name="auth[server]" value="<?php echo $host; ?>">
                                    <input type="hidden" name="auth[username]" value="<?php echo h($server["username"]); ?>">
                                    <input type="hidden" name="auth[password]" value="<?php echo h($server["pass"]); ?>">
                                    <input type='hidden' name="auth[db]" value="<?php echo h($database); ?>" />
                                    <input type='hidden' name="auth[permanent]" value="1" />
                                    <input type="submit" value="<?php echo lang('Enter'); ?>">
                                </form>
                            </td>
                        </tr>
                <?php
                    endforeach;
                endforeach;
                ?>
            </table>
        </div>
        <form action="" method="post">
    <?php
        return true;
    }
}
