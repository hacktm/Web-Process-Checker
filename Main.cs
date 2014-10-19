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

        int checkedProcessesCount = 0;

        public Main()
        {
            InitializeComponent();
            this.SizeChanged += new EventHandler(FormMinimized);
            dbTimer.Interval = 500;
            dbTimer.Elapsed += dbTimer_Elapsed;
            cmdTimer.Interval = 500;
            cmdTimer.Elapsed += cmdTimer_Elapsed;
            LoadList();
            this.ActiveControl = processesList;
        }

        private void LoadList()
        {
            processesList.Items.Clear();
            Process[] processes = Process.GetProcesses();
            foreach (Process process in processes)
            {
                processesList.Items.Add(process.ProcessName);
            }
        }

        private void dbTimer_Elapsed(object sender, System.Timers.ElapsedEventArgs e)
        {
            checkedProcessesCount = 0;
            for (int i = 0; i < processesList.Items.Count; i++)
                if (processesList.GetItemChecked(i) == true)
                {
                    checkedProcessesCount++;
                    string process_name = processesList.Items[i].ToString();
                    Process[] process = Process.GetProcessesByName(process_name);
                    if (process.Length != 0)
                    {
                        Web.GetPost(url.Text + "/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process_name, "ram", process[0].VirtualMemorySize64.ToString(), "peak", process[0].PeakVirtualMemorySize64.ToString(), "status", "1");
                    }
                    else
                    {
                        Web.GetPost(url.Text + "/handlers/update_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process_name, "ram", "0", "peak", "0", "status", "0");
                    }
                }
            notifyIcon.Text = "Monitoring " + checkedProcessesCount + " processes";
        }

        private void StopProcess(string process_name, bool uncheck = true)
        {
            try
            {
                Process[] proc = Process.GetProcessesByName(process_name);
                if (proc.Length != 0)
                {
                    Web.GetPost(url.Text + "/handlers/delete_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process_name);
                    proc[0].Kill();
                    if (uncheck)
                    {
                        for (int i = 0; i < processesList.Items.Count; i++)
                        {
                            if (processesList.Items[i].ToString() == process_name)
                                processesList.SetItemChecked(i, false);
                        }
                    }
                }
            }
            catch (Exception)
            {
                
            }
        }

        private void RestartProcess(string process_name)
        {
            try
            {
                string filename = null;
                Process[] proc = Process.GetProcessesByName(process_name);
                if(proc.Length != 0)
                {
                    filename = proc[0].MainModule.FileName;
                }
                StopProcess(process_name, false);
                Process.Start(filename);
            }
            catch (Exception)
            {
                
                
            }
        }

        private void cmdTimer_Elapsed(object sender, System.Timers.ElapsedEventArgs e)
        {
            try
            {
                string Data = Web.GetPost(url.Text + "/handlers/handler.php", "key", "jf9uh4iuhjf0wehfj93");
                string[] Command = Data.Split('|');
                switch (Command[0])
                {
                    case "StopProcess": StopProcess(Command[1]); break;
                    case "RestartProcess": RestartProcess(Command[1]); break;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void StartTimers()
        {
            try
            {
                dbTimer.Start();
                cmdTimer.Start();
                startBtn.Enabled = false;
                stopBtn.Enabled = true;
                statusLabel.Text = "";
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
                statusLabel.Text = "Choose one or more processes";
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
                    Web.GetPost(url.Text + "/handlers/delete_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", process);
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
                            Web.GetPost(url.Text + "/handlers/delete_db.php", "key", "jf9uh4iuhjf0wehfj93", "name", processesList.Items[i].ToString());
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

        private void reloadButton_Click(object sender, EventArgs e)
        {
            LoadList();
        }

        private void panelButton_Click(object sender, EventArgs e)
        {
            Process.Start(url.Text);
        }
    }
}
