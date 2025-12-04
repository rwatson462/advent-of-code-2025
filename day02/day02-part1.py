
def readFile():
    with open("python-input") as file:
        return file.read().strip().split(",")

contents = readFile()

ans = 0

for pair in contents:
    first,last = pair.split("-")
    for num in range(int(first),int(last)+1):
        numStr = str(num)
        numLen = len(numStr)

        if numLen % 2 == 1:
            continue

        # split number in half, check if first half equals second half
        firstHalf, secondHalf = numStr[0:int(numLen/2)], numStr[int(numLen/2):]

        if firstHalf == secondHalf:
            ans += num

print(ans)
