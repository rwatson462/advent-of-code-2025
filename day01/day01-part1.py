
def readFile():
    with open("python-input") as file:
        return [line.strip() for line in file]

contents = readFile()

pos = 50
ans = 0

for line in contents:
    dir, amt = line[0], int(line[1:])

    if dir == "L":
        pos -= amt
    else:
        pos += amt

    pos = (pos + 100) % 100

    # If we land exactly on zero, count towards answer
    if pos == 0:
        ans += 1

print(ans)
