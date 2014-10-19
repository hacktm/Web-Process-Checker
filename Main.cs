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
            this.SizeChanged += new EventHandler(FormMinimized);
            dbTimer.Interval = 5000;
            dbTimer.Elapsed += dbTimer_Elapsed;
            cmdTimer.Interval = 5000;
            cmdTimer.Elapsed += cmdTimer_Elapsed;

            Process[] processes = Process.GetProcesses();
            foreach(Process process in processes)
            {
                processesList.Items.Add(process.ProcessName);
            }
        }

        private void dbTimer_Elapsed(object sender, System.Timers.ElapsedEventArgs e)
        {
            for (int i = 0; i < processesList.Items.Count; i++)
                if (processesList.GetItemChecked(i) == true)
                {
                    string process_name = processesList.Items[i].ToString();
                    Process[] process = Process.GetProcessesByName(process_name);
                    if (process.Length != 0)
                    {
                        Web.GetPost("http://localhost/panel/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process_name, "ram", process[0].VirtualMemorySize64.ToString(), "peak", process[0].PeakVirtualMemorySize64.ToString(), "status", "1");
                    }
                    else
                    {
                        Web.GetPost("http://localhost/panel/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process_name, "ram", "0", "peak", "0", "status", "0");
                    }
                }
            notifyIcon.Text = "Monitoring " + processesList.Items.Count + " processes";
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
                startBtn.Enabled = false;
                stopBtn.Enabled = true;
                statusLabel.Text = "Monitoring " + processesList.Items.Count + " processes";
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
                startBtn.Enabled = true;
                stopBtn.Enabled = false;
                statusLabel.Text = "";
                notifyIcon.Text = "Idle";
                Uncheck();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
        }

        private void Uncheck(string process = null)
        {
            if (process != null)
            {
                try
                {
                    Web.GetPost("http://localhost/panel/handlers/delete_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process);
                }
                catch (Exception ex)
                {
                    MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
            else
            {
                try
                {
                    for (int i = 0; i < processesList.Items.Count; i++)
                    {
                        if(processesList.GetItemChecked(i))
                            Web.GetPost("http://localhost/panel/handlers/delete_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", processesList.Items[i].ToString());
                    }
                }
                catch (Exception ex)
                {
                    MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void startBtn_Click(object sender, EventArgs e)
        {
            StartTimers();
        }

        private void stopBtn_Click(object sender, EventArgs e)
        {
            StopTimers();

        }

        private void Main_FormClosing(object sender, FormClosingEventArgs e)
        {
            StopTimers();
        }

        private void FormMinimized(object sender, EventArgs e)
        {
            if (this.WindowState == FormWindowState.Minimized)
                this.Hide();
        }

        private void notifyIcon_MouseDoubleClick(object sender, MouseEventArgs e)
        {
            this.Show();
            WindowState = FormWindowState.Normal;
        }

        private void processesList_ItemCheck(object sender, ItemCheckEventArgs e)
        {
            if(e.NewValue == CheckState.Unchecked)
                Uncheck(processesList.Items[e.Index].ToString());
        }

        private void Main_KeyDown(object sender, KeyEventArgs e)
        {
            if(e.Control && e.KeyCode == Keys.A)
            {
                for (int i = 0; i < processesList.Items.Count; i++)
                {
                    processesList.SetItemChecked(i, true);
                }
            }
        }
    }
}
