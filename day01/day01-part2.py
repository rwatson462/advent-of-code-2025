
def readFile():
    with open("python-input") as file:
        return [line.strip() for line in file]

contents = readFile()

pos = 50
ans = 0

for line in contents:
    dir, amt = line[0], int(line[1:])

    # If we touch zero, count towards answer
    while amt > 0:
        if dir == "L":
            pos -= 1
        else:
            pos += 1

        amt -= 1
        pos = (pos + 100) % 100

        if pos == 0:
            ans += 1

print(ans)
