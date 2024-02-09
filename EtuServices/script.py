import redis
from datetime import datetime, timedelta
import json
import sys



# Connect to Redis server
r = redis.Redis(host='localhost', port=6379, decode_responses=True)


# user = r.get(userEmail)

def enableConnexion(userEmail):

    enableConnexion = 1

    # Get user 
    user = r.get(userEmail)

    # --If User doen't exist in redis create a new user
    if user is None:
        # Set timesatmp and nb connection for the user
        userInfo = {
            "timestamp": datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
            "nbConnection": 1
        }

        r.set(userEmail, json.dumps(userInfo))


        print("Create new user")


    else:
        # Get user info
        userInfo = r.get(userEmail)
        userInfo = json.loads(userInfo)

        if datetime.now() - datetime.strptime(userInfo["timestamp"], "%Y-%m-%d %H:%M:%S") > timedelta(minutes=10):
            # Reset user info with current timestamp and nb connection at 1
            userInfo["timestamp"] = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            userInfo["nbConnection"] = 1

            r.set(userEmail, json.dumps(userInfo))

            # print("Reset user info")
        else:
            # Increment nb connection
            userInfo["nbConnection"] += 1
            r.set(userEmail, json.dumps(userInfo))

            # print("Increment nb connection")

            if userInfo["nbConnection"] > 10:
                # Send email to user
                # print("Send email to user")

                enableConnexion = 0

    return enableConnexion


if __name__ == "__main__":

    # Get user email from command line
    userEmail = sys.argv[1]

    # Enable connexion or not
    print(enableConnexion(userEmail))