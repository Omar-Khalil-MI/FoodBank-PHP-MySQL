<?php
class ViewAbst
{
    function PrintFooter()
    {
        echo ('
                </table>
                </div>
                </div>
                <footer>
                    <p>© 2024 Food Bank</p>
                </footer>
                </body>
            </html>
        ');
    }
    function PrintMessage($succ)
    {
        if ($succ) {
            echo ('
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <p style="color: green; text-align: center; font-size: x-large; font-weight: bold;">
                        Operation was Successfull !
                    </p>
                </div>
            ');
        } else echo ('
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <p style="color: red; text-align: center; font-size:large; font-weight: bold;">
                        Operation was not Executed !
                    </p>
                </div>
            ');
    }
}
