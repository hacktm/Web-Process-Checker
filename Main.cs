using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Diagnostics;

namespace Process_Checker
{
    public partial class Main : Form
    {
        System.Timers.Timer dbTimer = new System.Timers.Timer();

        System.Timers.Timer cmdTimer = new System.Timers.Timer();

        public Main()
        {
            InitializeComponent();
            dbTimer.Interval = 5000;
            dbTimer.Elapsed += dbTimer_Elapsed;
            cmdTimer.Interval = 15000;
            cmdTimer.Elapsed += cmdTimer_Elapsed;
        }

        private bool CheckProcName(string procName)
        {
            try
            {
                Process[] proc = Process.GetProcessesByName(procName);
                if (proc.Length != 0)
                    return true;
                else
                    return false;
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
                return false;
            }
        }

        private void dbTimer_Elapsed(object sender, System.Timers.ElapsedEventArgs e)
        {
            Process[] proc1 = Process.GetProcessesByName(procBox1.Text);
            if(proc1.Length != 0)
            {
                Web.GetPost("http://localhost/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", procBox1.Text, "ram", proc1[0].VirtualMemorySize64.ToString(), "peak", proc1[0].PeakVirtualMemorySize64.ToString(),"status", "1");
            }
            else
            {
                Web.GetPost("http://localhost/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", procBox1.Text, "ram", "0", "peak", "0", "status", "0");
            }
            Process[] proc2 = Process.GetProcessesByName(procBox2.Text);
            if (proc2.Length != 0)
            {
                Web.GetPost("http://localhost/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", procBox2.Text, "ram", proc2[0].VirtualMemorySize64.ToString(), "peak", proc2[0].PeakVirtualMemorySize64.ToString(), "status", "1");
            }
            else
            {
                Web.GetPost("http://localhost/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", procBox2.Text, "ram", "0", "peak", "0", "status", "0");
            }
        }

        private void cmdTimer_Elapsed(object sender, System.Timers.ElapsedEventArgs e)
        {

        }

        public void StartTimers()
        {
            try
            {
                dbTimer.Start();
                cmdTimer.Start();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
        }

        private void StopTimers()
        {
            try
            {
                dbTimer.Stop();
                cmdTimer.Stop();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
        }

        private void startBtn_Click(object sender, EventArgs e)
        {
            if (!CheckProcName(procBox1.Text))
            {
                MessageBox.Show("Process #1 not found!", "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }
            if (!CheckProcName(procBox2.Text))
            {
                MessageBox.Show("Process #2 not found!", "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }
            StartTimers();
            procBox1.Enabled = false;
            procBox2.Enabled = false;
            startBtn.Enabled = false;
            stopBtn.Enabled = true;
            statusLabel.Text = "Running";
        }

        private void stopBtn_Click(object sender, EventArgs e)
        {
            StopTimers();
            procBox1.Enabled = true;
            procBox2.Enabled = true;
            startBtn.Enabled = true;
            stopBtn.Enabled = false;
            statusLabel.Text = "Not Running";
            try
            {
                Web.GetPost("http://localhost/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", procBox1.Text, "ram", "0", "peak", "0", "status", "0");
                Web.GetPost("http://localhost/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", procBox2.Text, "ram", "0", "peak", "0", "status", "0");
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }

        }
    }
}
