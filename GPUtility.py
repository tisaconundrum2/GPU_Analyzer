#!/usr/local/bin/python
import pip

pip.main(['install', 'GPUtil'])
pip.main(['install', 'requests'])
import getpass
import json
import os
import sys
from time import gmtime, strftime, sleep
import GPUtil
import platform
import requests


def printit(msg, bool=True):
    if bool:
        print(msg)


class GPUtil_data():
    def __init__(self, printoutputs=True):
        self.printoutputs = printoutputs
        self.gpu_data = [platform.node(),
                         0,  # idx:1  name: usage_0
                         0,  # idx:2  name: usage_10
                         0,  # idx:3  name: usage_20
                         0,  # idx:4  name: usage_30
                         0,  # idx:5  name: usage_40
                         0,  # idx:6  name: usage_50
                         0,  # idx:7  name: usage_60
                         0,  # idx:8  name: usage_70
                         0,  # idx:9  name: usage_80
                         0,  # idx:10 name: usage_90
                         getpass.getuser(),
                         strftime("%Y-%m-%d", gmtime())]
        self.load_gpu_file()
        self.usage = 0

    def load_gpu_file(self):
        date = strftime("%Y-%m-%d", gmtime())
        file = 'gputility' + date + '.dat'
        if os.path.isfile(file):
            with open(file, 'r') as fp:
                self.gpu_data = json.load(fp)

    def get_gpu_data(self, display=False):
        """
        This has to be run multiple times.
        Returns the usages of GPU
        Gives out usages in units of 10%s

        :return:

        """
        try:
            self.usage = GPUtil.getGPUs()[0].load * 100
        except:
            printit("This computer does not have a valid Nvidia GPU. Sending 0% as usage", self.printoutputs)
        if self.usage < 10:
            self.gpu_data[1] += 1
        elif self.usage < 20:
            self.gpu_data[2] += 1
        elif self.usage < 30:
            self.gpu_data[3] += 1
        elif self.usage < 40:
            self.gpu_data[4] += 1
        elif self.usage < 50:
            self.gpu_data[5] += 1
        elif self.usage < 60:
            self.gpu_data[6] += 1
        elif self.usage < 70:
            self.gpu_data[7] += 1
        elif self.usage < 80:
            self.gpu_data[8] += 1
        elif self.usage < 90:
            self.gpu_data[9] += 1
        else:
            self.gpu_data[10] += 1

        if display:
            printit(
                " {0:30s} | {1:7s} | {2:8s} | {3:8s} | {4:8s} | {5:8s} | {6:8s} | {7:8s} | {8:8s} | {9:8s} | {10:8s} | {11:8s} | {12:8s} ".format(
                    "Computer Name", "usage_0", "usage_10", "usage_20", "usage_30", "usage_40", "usage_50", "usage_60",
                    "usage_70", "usage_80", "usage_90", "User", "Date"), self.printoutputs)
            printit(
                " {0:30s} | {1:7d} | {2:8d} | {3:8d} | {4:8d} | {5:8d} | {6:8d} | {7:8d} | {8:8d} | {9:8d} | {10:8d} | {11:8s} | {12:8s} ".format(
                    self.gpu_data[0],  # This printing really needs to be refactored...
                    self.gpu_data[1],  # There should be a more pretty one-liner somewhere
                    self.gpu_data[2],
                    self.gpu_data[3],
                    self.gpu_data[4],
                    self.gpu_data[5],
                    self.gpu_data[6],
                    self.gpu_data[7],
                    self.gpu_data[8],
                    self.gpu_data[9],
                    self.gpu_data[10],
                    self.gpu_data[11],
                    self.gpu_data[12]), self.printoutputs)

    def run_backup(self):
        date = strftime("%Y-%m-%d", gmtime())
        file = 'gputility' + date + '.dat'
        with open(file, 'w') as fp:
            json.dump(self.gpu_data, fp, indent=4)

    def push_gpu_data(self):
        mydata = {
            "ComputerName": str(self.gpu_data[0]),
            "usage_0": str(self.gpu_data[1]),
            "usage_10": str(self.gpu_data[2]),
            "usage_20": str(self.gpu_data[3]),
            "usage_30": str(self.gpu_data[4]),
            "usage_40": str(self.gpu_data[5]),
            "usage_50": str(self.gpu_data[6]),
            "usage_60": str(self.gpu_data[7]),
            "usage_70": str(self.gpu_data[8]),
            "usage_80": str(self.gpu_data[9]),
            "usage_90": str(self.gpu_data[10]),
            "User": str(self.gpu_data[11]),
            "Date": str(self.gpu_data[12]),
        }
        path = 'http://cidse-gputil.cidse.dhcp.asu.edu/get_data.php'  # the url you want to POST to
        req = requests.post(path, mydata)
        printit(req.text, self.printoutputs)


gpu_data = GPUtil_data(False)
args = sys.argv[1:]
if args == ['--display'] or args == ['-d']:
    gpu_data = GPUtil_data(True)
elif args == ['--author']:
    print("Author: Nicholas Finch <ngfinch@asu.edu>")
    exit()
elif args == ['-h'] or args == ['--help']:
    print("""Usage: python GPUtility.py [OPTION]...
Usage: GPUtility.exe [OPTION]...
GPUtility is a script designed to help IT gather information on GPU 
utilizations across the network

    -d, --display            display the usage data of your GPU
    -h, --help               display this help dialog
        --author             display the author of this script
""")
    exit()
while True:
    for i in range(10):  # update the server every 10 seconds
        gpu_data.get_gpu_data(True)
        gpu_data.run_backup()
        sleep(1)  # sleep for a second
    gpu_data.push_gpu_data()  # push the data to the server
