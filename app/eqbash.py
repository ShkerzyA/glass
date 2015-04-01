#!/usr/bin/python2
import subprocess,re,os,sys
PIPE = subprocess.PIPE
def bash(cmd):
	p = subprocess.Popen(cmd, shell=True, stdin=PIPE, stdout=PIPE,
        stderr=subprocess.STDOUT, close_fds=True, cwd="/home/")
	res=p.stdout.read()
	return res

def info(ip):
	#nmap=bash("ping -c 1 -W 1 "+ip)
	mac=bash("arp "+ip)
	name=bash("nmblookup -A "+ip)
	print(mac+name)
	maclist=re.findall("\S\S:\S\S:\S\S:\S\S:\S\S:\S\S", mac)
	wg_set=set(['WORKGROUP','MAC','KKOC','MOSYS','MSHOME'])

	words=set(re.findall("(?<=\s)+[A-Z_-]{2,}(?=\s)", name))
	nm=list(words-wg_set)
	return {"ip":ip,"mac":maclist,"nm":nm}

#alladr=bash("nmap -sP 10.126.80.0/20")
#ipall=re.findall("\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}", alladr)


def one_node():
	pass
def all_node():
	pass

if len(sys.argv)>1:
	fname='ipinfo';
	ipall=[str(sys.argv[1])]
else:
	fname='netinfo';
	ipall=list()
	for x in range(80,85):
		for y in range(1,255):
			rawip=('ping -c 1 -W 1 10.126.'+str(x)+'.'+str(y))
			ip=re.findall("\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}", rawip)
			if ip:
				ipall.append(str(ip[0]))


path=os.path.dirname(__file__)+"/"+fname+".txt"
f=open(path,'w')
f.write('[\n\t{"ip":"0.0.0.0","mac":["00:00:00:00:00:00"],"nm":[]}')
for ip in ipall:
	f.write(",\n\t"+str(info(ip)).replace("'",'"'))
f.write("\n]")

f.close() 


