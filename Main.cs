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
                        Web.GetPost("http://10.0.186.210/panel/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process_name, "ram", process[0].VirtualMemorySize64.ToString(), "peak", process[0].PeakVirtualMemorySize64.ToString(), "status", "1");
                    }
                    else
                    {
                        Web.GetPost("http://10.0.186.210/panel/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process_name, "ram", "0", "peak", "0", "status", "0");
                    }
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
            StartTimers();
            startBtn.Enabled = false;
            stopBtn.Enabled = true;
            statusLabel.Text = "Running";
        }

        private void stopBtn_Click(object sender, EventArgs e)
        {
            StopTimers();
            startBtn.Enabled = true;
            stopBtn.Enabled = false;
            statusLabel.Text = "Not Running";
            try
            {
                for (int i = 0; i < processesList.Items.Count; i++)
                {
                    processesList.SetItemChecked(i, false);
                    string process_name = processesList.Items[i].ToString();
                    Web.GetPost("http://10.0.186.210/panel/handlers/delete_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process_name);
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }

        }
    }
}
