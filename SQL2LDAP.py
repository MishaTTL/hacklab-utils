import mysql.connector

mydb = mysql.connector.connect(
        host="localhost",
        user="",
        passwd="",
        database="memberdb"
)

mycursor = mydb.cursor()

mycursor.execute("SELECT id,cn,givenName,sn,uid,mail FROM ldap_people")

myresult = mycursor.fetchall()

#Writes the .ldif formatted output
for r in myresult:
        uid = 100000 + int(r[0])

        print("dn: uid=%s,ou=People,dc=hacklab,dc=to" % r[4])
        print("cn: %s" % r[1])
        print("objectClass: top")
        print("objectClass: person")
        print("objectClass: organizationalPerson")
        print("objectClass: inetOrgPerson")
        print("objectClass: shadowAccount")
        print("objectClass: posixAccount")
        print("loginShell: /bin/bash")
        print("homeDirectory: /home/%s" % r[1])
        print("gidNumber: 100000")
        print("sn: %s" % r[3])
        print("mail: %s" % r[5])
        print("uid: %s" % r[4])
        print("uidNumber: %i" % uid)
        print("givenName: %s" % r[2])
        print("")

