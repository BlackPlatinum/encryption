/**
 * @author  Baha2r
 * @license MIT
 * Date: 31/Oct/2019 00:31 AM
 *
 * Master IV generator
 **/

#include "master_iv.h"

using namespace std;

// generator() prototype
string generator();

/**
 * Main function
 */
int main() {
    string a = generator();
    cout << a;
    return 0;
}


/**
 * Generates random master key
 * @return string return master key as a string
 */
string generator() {
    const int BLOCK_SIZE = 16;
    int *buff = new int[BLOCK_SIZE];
    char *bytes = new char[BLOCK_SIZE];
    srand(17);
    for (int i = 0; i < BLOCK_SIZE; i++) {
        buff[i] = (int) (-3 * random());
    }
    for (int i = 0; i < BLOCK_SIZE; i++) {
        bytes[i] = (char) (buff[i] + '0');
    }
    delete[] buff;
    string byte_str = "";
    for (int i = 0; i < BLOCK_SIZE; i++) {
        byte_str += bytes[i];
    }
    delete[] bytes;
    return byte_str;
}